@extends('service_provider.serviceprovider_Dashboard')
@section('title', 'All Categories')

@section('service_provider')
<div class="page-content">
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Categories</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="#"><i class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item active" aria-current="page">All Categories</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="d-flex align-items-center mb-3">
                <h5>All Categories</h5>
                <div class="ms-auto">
                    <a href="{{ route('provider.categories.create') }}" class="btn btn-success btn-sm">
                        <i class="fas fa-plus"></i> Add Category
                    </a>
                </div>
            </div>

            @if(session('msg'))
                <div class="alert alert-{{ session('type') ?? 'info' }} alert-dismissible fade show" role="alert">
                    {{ session('msg') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <table class="table table-bordered text-center align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($categories as $category)
                    <tr>
                        <td>{{ $category->id }}</td>
                        <td>{{ $category->name }}</td>
                        <td>{{ $category->description }}</td>
                        <td>
                            <a href="{{ route('provider.categories.edit', $category->id) }}" class="btn btn-info btn-sm">
                                <i class="fas fa-edit"></i>
                            </a>

                            <form action="{{ route('provider.categories.destroy', $category->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('هل أنت متأكد من حذف هذا التصنيف؟')" class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-danger">No categories found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-3 float-end">
                {{ $categories->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
