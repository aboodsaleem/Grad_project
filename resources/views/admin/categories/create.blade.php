@extends('admin.admin_Dashboard')
@yield('title', 'All Categories')

@section('css')

@endsection
@section('admin')
<div class="page-content">
				<!--breadcrumb-->
				<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
					<div class="breadcrumb-title pe-3">Category</div>
					<div class="ps-3">
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb mb-0 p-0">
								<li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
								</li>
								<li class="breadcrumb-item active" aria-current="page">Add Categories</li>
							</ol>
						</nav>
					</div>
				</div>
				<!--end breadcrumb-->
				<div class="row">
					<div class="col-xl-9 mx-auto">
						<hr/>
						<div class="card">
							<div class="card-body">
								<form action="{{ route('admin.categories.store')}}" method="POST">
                                    @csrf
                                    <div class="mb-3">
									    <label> Name</label>
                                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder=" Name" />
                                        @error('name')
                                            <small class="invalid-feedback">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label> Description</label>
                                        <textarea name="description" class="form-control @error('description') is-invalid @enderror" placeholder="Enter Description" rows="4"></textarea>
                                        @error('description')
                                            <small class="invalid-feedback">{{ $message }}</small>
                                        @enderror
                                    </div>
                                            <button class="btn btn-success"><i class="fas fa-save mr-1 ml-1"></i>Add Category</button>

								</form>
							</div>
						</div>



					</div>
				</div>
				<!--end row-->
			</div>
@endsection

