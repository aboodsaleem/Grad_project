@extends('admin.admin_Dashboard')
@section('title', 'User View')
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
								<li class="breadcrumb-item active" aria-current="page">User View</li>
							</ol>
						</nav>
					</div>
					<div class="ms-auto">

					</div>
				</div>
				<!--end breadcrumb-->
				<div class="container">
					<div class="main-body">
						<div class="row">
							<div class="col-md-12">
								<div class="card">
                                    <form>
                                        <div class="card-body">
                                            <div class="row mb-3">
    <div class="col-sm-3">
        <h6 class="mb-0">Image</h6>
    </div>
    <div class="col-sm-9 text-secondary">
        <img id="showImage" class="img-thumbnail rounded-circle shadow"
             src="{{ asset($dataUsers->photo ?? 'upload/no_img.jpg') }}"
             alt="Profile Image" width="120" height="120">
    </div>
</div>


                                            <div class="row mb-3">
                                                <div class="col-sm-3">
                                                    <h6 class="mb-0">Username</h6>
                                                </div>
                                                <div class="col-sm-9 text-secondary">
                                                    <input type="text" name="username" class="form-control" value="{{ $dataUsers->username }}" />
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-sm-3">
                                                    <h6 class="mb-0">Email</h6>
                                                </div>
                                                <div class="col-sm-9 text-secondary">
                                                    <input type="email" name="email" class="form-control" value="{{ $dataUsers->email }}" />
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-sm-3">
                                                    <h6 class="mb-0">Phone</h6>
                                                </div>
                                                <div class="col-sm-9 text-secondary">
                                                    <input type="text" name="phone" class="form-control" value="{{ $dataUsers->phone }}" />
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-sm-3">
                                                    <h6 class="mb-0">Address</h6>
                                                </div>
                                                <div class="col-sm-9 text-secondary">
                                                    <input type="text" name="address" class="form-control" value="{{ $dataUsers->address }}" />
                                                </div>
                                            </div>

                                                <a href="{{ route('admin.users.list', $dataUsers->id) }}" class="btn btn-primary">Back</a>
                                        </div>
                                    </div>
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


