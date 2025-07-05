@extends('admin.admin_Dashboard')
@section('title', 'Users List')

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
        <div class="breadcrumb-title pe-3">Users</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item active" aria-current="page">Users List</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-12 mx-auto">
            <div class="card radius-10">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div><h5 class="mb-0">Users List</h5></div>
                        <div class="ms-auto">
                            <a href="{{ route('admin.users.trashed') }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-trash"></i> Trashed
                            </a>
                        </div>
                    </div>

                    @include('admin.msg')
                    <hr>

                    <div class="table-responsive" style="overflow-x: auto;">
                        <table class="table table-bordered table-hover table-striped align-middle text-center mb-0" style="white-space: nowrap;">
                            <thead class="table-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Photo</th>
                                    <th>Phone</th>
                                    <th>Address</th>
                                    <th>Role</th>
                                    <th>Status</th>
                                    <th>Created</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($dataUsers as $dataUser)
                                    <tr>
                                        <th>{{ $dataUser->id }}</th>
                                        <td>{{ $dataUser->username }}</td>
                                        <td>{{ $dataUser->email }}</td>
                                        <td>
                                            <img src="{{ asset($dataUser->photo ?? 'upload/no_img.jpg') }}" class="img-thumbnail rounded-circle shadow" style="width:50px; height:50px;" alt="">
                                        </td>
                                        <td>{{ $dataUser->phone }}</td>
                                        <td>{{ $dataUser->address }}</td>
                                        <td>
                                            @if ($dataUser->role == 'admin')
                                                <span class="badge bg-info">Admin</span>
                                            @elseif ($dataUser->role == 'service_provider')
                                                <span class="badge bg-success">Service Provider</span>
                                            @elseif ($dataUser->role == 'customer')
                                                <span class="badge bg-primary">Customer</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($dataUser->status == 'active')
                                                <div class="badge rounded-pill bg-light-success text-success w-100">Active</div>
                                            @else
                                                <div class="badge rounded-pill bg-light-danger text-danger w-100">Inactive</div>
                                            @endif
                                        </td>
                                        <td>{{ $dataUser->created_at ? $dataUser->created_at->format('d-m-Y') : '-' }}</td>
                                        <td>
                                            <a class="btn btn-sm btn-info mb-1" href="{{ route('admin.users.view', $dataUser->id) }}">
                                                <i class="fa fa-eye"></i>
                                            </a>

                                            @if (is_null($dataUser->deleted_at))
                                                <button type="button" class="btn btn-sm btn-warning mb-1 delete-btn"
                                                    data-url="{{ route('admin.users.softDelete', $dataUser->id) }}"
                                                    data-title="هل أنت متأكد من الحذف المؤقت؟"
                                                    data-confirm="نعم، احذفه"
                                                    data-cancel="إلغاء"
                                                    data-method="DELETE">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            @else
                                                <button type="button" class="btn btn-sm btn-success mb-1 restore-btn"
                                                    data-url="{{ route('admin.users.restore', $dataUser->id) }}"
                                                    data-title="هل تريد استرجاع هذا المستخدم؟"
                                                    data-confirm="نعم، استرجاع"
                                                    data-cancel="إلغاء">
                                                    <i class="fas fa-undo"></i>
                                                </button>

                                                <button type="button" class="btn btn-sm btn-danger mb-1 delete-btn"
                                                    data-url="{{ route('admin.users.forceDelete', $dataUser->id) }}"
                                                    data-title="هل تريد الحذف النهائي؟"
                                                    data-confirm="نعم، احذفه نهائيًا"
                                                    data-cancel="إلغاء"
                                                    data-method="DELETE">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3" style="float: right;">
                        {{ $dataUsers->links() }}
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
