@extends('admin.admin_Dashboard')
@section('title', 'Trashed Categories')

@section('admin')
<div class="page-content">
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Trashed Categories</div>
    </div>

    <div class="row">
        <div class="col-xl-12 mx-auto">
            <div class="card radius-10">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <h5 class="mb-0">Categories in Trash</h5>
                        <div class="ms-auto">
                            <a href="{{ route('admin.categories.index') }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-arrow-left"></i> Back to Categories
                            </a>
                        </div>
                    </div>

                    @include('admin.msg')
                    <hr>

                    <div class="table-responsive">
                        <table class="table table-bordered text-center align-middle mb-0">
                            <thead class="table-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Deleted At</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($categories as $category)
                                <tr class="table-danger">
                                    <td>{{ $category->id }}</td>
                                    <td>{{ $category->name }}</td>
                                    <td>{{ $category->description }}</td>
                                    <td>{{ $category->deleted_at->format('Y-m-d H:i') }}</td>
                                    <td>
                                        <form action="{{ route('admin.categories.restore', $category->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('PUT')
                                            <button type="button" class="btn btn-success btn-sm restore-btn"
                                                data-url="{{ route('admin.categories.restore', $category->id) }}"
                                                data-title="Restore this category?"
                                                data-confirm="Yes, restore"
                                                data-cancel="Cancel">
                                                <i class="fas fa-undo"></i>
                                            </button>
                                        </form>

                                        <form action="{{ route('admin.categories.forceDelete', $category->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-danger btn-sm delete-btn"
                                                data-url="{{ route('admin.categories.forceDelete', $category->id) }}"
                                                data-title="Delete permanently?"
                                                data-confirm="Yes, delete"
                                                data-cancel="Cancel"
                                                data-method="DELETE">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-danger">No trashed categories found.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3 float-end">
                        {{ $categories->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
@include('admin.partials.sweetalert_actions')
@endsection
