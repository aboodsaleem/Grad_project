@extends('admin.admin_Dashboard')
@section('title', 'All Categories')

@section('css')
<style>
    .btn i {
        vertical-align: middle;
        font-size: 1.3rem;
        margin-top: 0em;
        margin-bottom: 0em;
        margin-right: 5px;
    }
</style>
@endsection

@section('admin')
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

    <div class="row">
        <div class="col-xl-12 mx-auto">
            <div class="card radius-10">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <h5 class="mb-0">All Categories</h5>
                        <div class="ms-auto">
                            <a href="{{ route('admin.categories.trashed') }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-trash"></i> Trashed
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
                                        <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-info btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <form action="{{ route('admin.categories.softDelete', $category->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-warning btn-sm delete-btn"
                                                data-url="{{ route('admin.categories.softDelete', $category->id) }}"
                                                data-title="Are you sure you want to delete this category?"
                                                data-confirm="Yes, delete it!"
                                                data-cancel="Cancel"
                                                data-method="DELETE">
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
