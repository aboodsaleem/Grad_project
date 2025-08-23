@extends('admin.admin_Dashboard')
@section('title', 'Trashed Users')

@section('admin')
<div class="page-content">
    <!-- Breadcrumb -->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Users</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item active" aria-current="page">Trashed Users</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- End breadcrumb -->

    <div class="row">
        <div class="col-xl-12 mx-auto">
            <div class="card radius-10">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <h5 class="mb-0">Users in Trash</h5>
                        </div>
                        <div class="ms-auto">
                            <a href="{{ route('admin.users.list') }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-arrow-left"></i> Back to All Users
                            </a>
                        </div>
                    </div>
                    @include('admin.msg')
                    <hr>


                    <div class="table-responsive" style="overflow-x: auto;">
                        <table class="table table-bordered table-hover table-striped align-middle text-center mb-0">
                            <thead class="table-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Deleted At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($trashedUsers as $user)
                                <tr class="table-danger">
                                    <td>{{ $user->id }}</td>
                                    <td>{{ $user->username }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->deleted_at->format('d-m-Y H:i') }}</td>
                                    <td>
                                       <!-- Restore Button -->
                                        <form action="{{ route('admin.users.restore', $user->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('PUT')
                                            <button type="button"
                                                class="btn btn-success btn-sm restore-btn"
                                                data-id="{{ $user->id }}"
                                                data-title="Are you sure you want to restore this user?"
                                                data-confirm="Yes, restore it!"
                                                data-cancel="Cancel"
                                                data-url="{{ route('admin.users.restore', $user->id) }}"
                                                title="Restore"
                                                data-bs-toggle="tooltip">
                                                <i class="fas fa-undo"></i>
                                            </button>
                                        </form>
                                        
                                        <!-- Force Delete Button -->
                                        <form action="{{ route('admin.users.forceDelete', $user->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button"
                                                class="btn btn-danger btn-sm delete-btn"
                                                data-id="{{ $user->id }}"
                                                data-title="Are you sure you want to permanently delete this user?"
                                                data-confirm="Yes, delete it!"
                                                data-cancel="Cancel"
                                                data-success="User permanently deleted"
                                                data-url="{{ route('admin.users.forceDelete', $user->id) }}"
                                                title="Delete Permanently"
                                                data-bs-toggle="tooltip">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </form>

                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="10" class="text-danger">There are no deleted users</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div style="padding: 20px; float: right;">
                        {{ $trashedUsers->links() }}
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
