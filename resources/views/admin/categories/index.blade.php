@extends('admin.admin_Dashboard')
@section('title', 'All Categories')

@section('css')
<style>
    .btn i {
        vertical-align: middle;
        font-size: 1.3rem;
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
                            <a href="{{ route('admin.categories.create') }}" class="btn btn-success btn-sm">
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

                                        <button type="button" class="btn btn-danger btn-sm delete-btn"
                                            data-url="{{ route('admin.categories.destroy', $category->id) }}"
                                            data-title="هل أنت متأكد من حذف هذا التصنيف نهائيًا؟"
                                            data-confirm="نعم، احذفه"
                                            data-cancel="إلغاء">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.querySelectorAll('.delete-btn').forEach(button => {
    button.addEventListener('click', function () {
        const url = this.dataset.url;
        const title = this.dataset.title || "هل أنت متأكد؟";
        const confirmText = this.dataset.confirm || "نعم، احذف";
        const cancelText = this.dataset.cancel || "إلغاء";

        Swal.fire({
            title: title,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: confirmText,
            cancelButtonText: cancelText,
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(url, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                    },
                })
                .then(response => {
                    if (response.ok) {
                        Swal.fire('تم الحذف!', '', 'success').then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire('حدث خطأ!', '', 'error');
                    }
                })
                .catch(() => {
                    Swal.fire('حدث خطأ!', '', 'error');
                });
            }
        });
    });
});
</script>
@endsection
