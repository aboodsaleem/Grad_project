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
        <div class="col-lg-12 stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">
                        Search Users
                    </h6>
                    <form method="GET" action="{{ route('admin.users.list') }}">
                        <div class="row">

                            <div class="col-sm-2">
                                <div class="mb-3">
                                    <label for="" class="form-label">ID</label>
                                    <input type="text" class="form-control" name="id" placeholder="Enter ID">
                                </div>
                            </div>

                            <div class="col-sm-2">
                                <div class="mb-3">
                                    <label for="" class="form-label">User Name</label>
                                    <input type="text" class="form-control" name="username" placeholder="Enter User Name">
                                </div>
                            </div>

                            <div class="col-sm-2">
                                <div class="mb-3">
                                    <label for="" class="form-label">Email</label>
                                    <input type="email" class="form-control" name="email" placeholder="Enter Email">
                                </div>
                            </div>

                            <div class="col-sm-2">
                                <div class="mb-3">
                                    <label for="" class="form-label">Phone</label>
                                    <input type="number" class="form-control" name="phone" placeholder="Enter Phone Number">
                                </div>
                            </div>

                            <div class="col-sm-2">
                                <div class="mb-3">
                                    <label for="" class="form-label">Role</label>
                                    <select class="form-control" name="role" >
                                        <option value="">Select Role</option>
                                        <option value="admin">Admin</option>
                                        <option value="service_provider">Service Provider</option>
                                        <option value="customer">Customer</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-2">
                                <div class="mb-3">
                                    <label for="" class="form-label">Status</label>
                                    <select class="form-control" name="status">
                                        <option value="">Select Status</option>
                                        <option value="active">Active</option>
                                        <option value="inactive">InActive</option>
                                    </select>
                                </div>
                            </div>

                        </div>
                        <button type="submit" class="btn btn-primary">Search</button>
                        <a href="{{ route('admin.users.list') }}" class="btn btn-danger">Reset</a>
                    </form>
                </div>
            </div>

        </div>
    </div>
    <br>

    <div class="row">
        <div class="col">
            <div class="d-flex align-items-center mb-3">
    <a href="{{ route('admin.users.list', ['role' => 'admin']) }}" class="btn btn-info">
        Admin <span class="badge bg-dark">{{ $countAdmins }}</span>
    </a>&nbsp;&nbsp;

    <a href="{{ route('admin.users.list', ['role' => 'service_provider']) }}" class="btn btn-warning">
        Service Provider <span class="badge bg-dark">{{ $countProviders }}</span>
    </a>&nbsp;&nbsp;

    <a href="{{ route('admin.users.list', ['role' => 'customer']) }}" class="btn btn-secondary">
        Customer <span class="badge bg-dark">{{ $countCustomers }}</span>
    </a>&nbsp;&nbsp;

    <a href="{{ route('admin.users.list', ['status' => 'active']) }}" class="btn btn-success">
        Active <span class="badge bg-dark">{{ $countActive }}</span>
    </a>&nbsp;&nbsp;

    <a href="{{ route('admin.users.list', ['status' => 'inactive']) }}" class="btn btn-danger">
        InActive <span class="badge bg-dark">{{ $countInactive }}</span>
    </a>&nbsp;&nbsp;

    <a href="{{ route('admin.users.list') }}" class="btn btn-primary">
        Total <span class="badge bg-dark">{{ $countTotal }}</span>
    </a>&nbsp;&nbsp;
</div>

        </div>
    </div>


    <div class="row">
        <div class="col-xl-12 mx-auto">
            <div class="card radius-10">
                <div class="card-body">
                <div class="d-flex align-items-center">
                    <div><h5 class="">Users List</h5></div>
                    <div class="ms-auto mb-2">
                        <a href="{{ route('admin.users.trashed') }}" class="btn btn-warning">
                            <i class="fas fa-trash"></i> Trashed
                        </a>
                        <a href="{{ route('admin.users.add') }}" class="btn btn-primary">Add User</a>
                    </div>
                </div>
                @include('admin.msg')

                <div class="table-responsive" style="overflow-x: auto;">
                        <table class="table table-bordered table-hover table-striped align-middle text-center mb-0" style="white-space: nowrap;">
                            <thead class="table-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Photo</th>
                                    <th>Phone</th>
                                    <th>Role</th>
                                    <th>Status</th>
                                    <th>Created</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <th>{{ $user->id }}</th>
                                        <td>{{ $user->username }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            <img src="{{ asset($user->photo ?? 'upload/no_img.jpg') }}" class="img-thumbnail rounded-circle shadow" style="width:50px; height:50px;" alt="">
                                        </td>
                                        <td>{{ $user->phone }}</td>
                                        <td>
                                            @if ($user->role == 'admin')
                                                <span class="badge bg-info">Admin</span>
                                            @elseif ($user->role == 'service_provider')
                                                <span class="badge bg-success">Service Provider</span>
                                            @elseif ($user->role == 'customer')
                                                <span class="badge bg-primary">Customer</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($user->status == 'active')
                                                <div class="badge rounded-pill bg-light-success text-success w-100">Active</div>
                                            @else
                                                <div class="badge rounded-pill bg-light-danger text-danger w-100">Inactive</div>
                                            @endif
                                        </td>
                                        <td>{{ $user->created_at ? $user->created_at->format('d-m-Y') : '-' }}</td>
                                        <td>
    <a class="btn btn-sm btn-info" href="{{ route('admin.users.view', $user->id) }}">
        <i class="fa fa-eye"></i>
    </a>

    <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-primary" title="Edit">
        <i class="fas fa-edit"></i>
    </a>

    <!-- زر الحذف المؤقت فقط -->
    <button type="button" class="btn btn-sm btn-warning delete-btn"
        data-url="{{ route('admin.users.softDelete', $user->id) }}"
        data-title="هل أنت متأكد من الحذف المؤقت؟"
        data-confirm="نعم، احذفه"
        data-cancel="إلغاء"
        data-method="DELETE">
        <i class="fas fa-trash-alt"></i>
    </button>
</td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3" style="float: right;">
                        {{ $users->links() }}
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
