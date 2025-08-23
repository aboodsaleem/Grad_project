@extends('admin.admin_Dashboard')
@section('title', 'Add User')
@section('css')

@endsection


@section('admin')

<div class="page-content">
				<!--breadcrumb-->
				<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
					<div class="breadcrumb-title pe-3">User</div>
					<div class="ps-3">
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb mb-0 p-0">
								<li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
								</li>
								<li class="breadcrumb-item active" aria-current="page">Add User</li>
							</ol>
						</nav>
					</div>
					<div class="ms-auto">

					</div>
				</div>
				<!--end breadcrumb-->
                <div class="row">
				<div class="col-md-12 grid-margin stretch-card">
						<div class="card">
							<div class="card-body">
								<div class="d-flex align-items-center">
                                    <h5 class="mb-0">Add User</h5>

                                </div>
                                <hr>
                                @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                                @endif

								<form class="forms-sample" method="post" action="{{ route('admin.users.store') }}">
                                    @csrf
									<div class="row mb-3">
										<label class="col-sm-3 col-form-label">Username <span style="color: red;">*</span> </label>
										<div class="col-sm-9">
											<input type="text" class="form-control" name="username" placeholder="Enter Username" required>
										</div>
									</div>
									<div class="row mb-3">
										<label class="col-sm-3 col-form-label">Email <span style="color: red;">*</span></label>
										<div class="col-sm-9">
											<input type="email" class="form-control" name="email" placeholder="Email" required>
                                            @error('email')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
										</div>
									</div>
                                    <div class="row mb-3">
                                        <label class="col-sm-3 col-form-label">Password <span style="color: red;">*</span></label>
                                        <div class="col-sm-9">
                                            <input type="password" class="form-control" name="password" placeholder="Enter password" required>
                                        </div>
                                    </div>

									<div class="row mb-3">
										<label class="col-sm-3 col-form-label">Phone <span style="color: red;">*</span></label>
										<div class="col-sm-9">
											<input type="number" class="form-control" name="phone" placeholder="Phone number" required>
										</div>
									</div>
                                    <div class="row mb-3">
										<label class="col-sm-3 col-form-label">Role <span style="color: red;">*</span></label>
										<div class="col-sm-9">
											<select class="form-control" name="role" required>
                                                <option value="">Select Role</option>
                                                <option value="admin">Admin</option>
                                                <option value="service_provider">Service Provider</option>
                                                <option value="customer">Customer</option>
                                            </select>
										</div>
									</div>

                                    <div class="row mb-3">
										<label class="col-sm-3 col-form-label">Status <span style="color: red;">*</span></label>
										<div class="col-sm-9">
											<select class="form-control" name="status" required>
                                                <option value="">Select Status</option>
                                                <option value="active">Active</option>
                                                <option value="inactive">InActive</option>
                                            </select>
										</div>
									</div>


									<button type="submit" class="btn btn-primary me-2">Add New User</button>
									<a href="{{ route('admin.users.list') }}" class="btn btn-secondary">Back</a>
								</form>

							</div>
						</div>
					</div>
			</div>
            </div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
$(document).ready(function() {
    $('#image').change(function(e) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#showImage').attr('src', e.target.result);
        }
        reader.readAsDataURL(e.target.files[0]);
    });
})


</script>

@section('js')

@endsection

@endsection


