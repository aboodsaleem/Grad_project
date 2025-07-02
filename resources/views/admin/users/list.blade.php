@extends('admin.admin_Dashboard')
@yield('title', 'Users List')

@section('css')

@endsection
@section('admin')
<!--breadcrumb-->
<div class="page-content">
				<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
					<div class="breadcrumb-title pe-3">Users</div>
					<div class="ps-3">
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb mb-0 p-0">
								<li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
								</li>
								<li class="breadcrumb-item active" aria-current="page">Users List</li>
							</ol>
						</nav>
					</div>

				</div>
				<!--end breadcrumb-->
				<div class="row">
					<div class="col-xl-12 mx-auto">
                        <div class="card radius-10">
						<div class="card-body">
							<div class="d-flex align-items-center">
								<div>
									<h5 class="mb-0">Users List</h5>
								</div>
								<div class="font-22 ms-auto"><i class="bx bx-dots-horizontal-rounded"></i>
								</div>
							</div>
							<hr>
							<div class="table-responsive">
								<table class="table table-bordered mb-0">
									<thead class="table-dark">
                                        <tr>
											<th scope="col">#</th>
											<th scope="col">Username</th>
											<th scope="col">Email</th>
											<th scope="col">Photo</th>
											<th scope="col">Phone</th>
											<th scope="col">Address</th>
											<th scope="col">Role</th>
											<th scope="col">Satus</th>
											<th scope="col">Created</th>
											<th scope="col">Action</th>
										</tr>

									</thead>
									<tbody>
                                        @foreach ($dataUsers as $dataUser)
                                        <tr>
											<th scope="row">{{ $dataUser->id }}</th>
											<td>{{ $dataUser->username }}</td>
											<td>{{ $dataUser->email }}</td>
											<td>

                                                {{-- @if ($dataUser->photo) --}}
                                                {{-- <img id="showImage" class="img-thumbnail rounded-circle shadow"
                                                    src="{{ asset($dataUser->photo) }}"
                                                    alt="" width="120" height="120"> --}}
                                                <img src="{{ asset($dataUser->photo?? 'upload/no_img.jpg') }}" class="img-thumbnail rounded-circle shadow" style="width:50px; height:50px;" alt="" srcset="">
                                                {{-- @endif --}}
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
                                                <span class="badge bg-success">Active</span>
                                                @else
                                                <span class="badge bg-primary">InActive</span>

                                                @endif
                                            </td>
											<td>{{ date('d-m-Y', strtotime($dataUser->created_at)) }}</td>
                                            <td>
                                                <a class="dropdown-item" href="{{ route('admin.users.view', $dataUser->id) }}">
                                                <i class="fa-solid fa-eye"></i><span>View</span>
                                                </a>
                                                {{-- <a class="dropdown-item" href="{{ route('admin.users.view') }}"><i class="fa-solid fa-eye"></i><span>View</span></a> --}}
                                            </td>
										</tr>
                                    @endforeach

									</tbody>
								</table>
							</div>
                            <!-- Pagination Links -->
                    <div style="padding: 20px; float: right;">
                        {{ $dataUsers->links() }}
                    </div>
						</div>
					</div>

					</div>

				</div>

				<!--end row-->
</div>
@endsection
