@extends('admin.admin_Dashboard')
@yield('title', 'All Categories')

@section('css')
<style>
    .btn i {
    vertical-align: middle;
    font-size: 1.3rem;
    margin-top: 0em;
    margin-bottom: 0em;
    margin-right: 0px;
}
</style>
@endsection
@section('admin')
<!--breadcrumb-->
<div class="page-content">
				<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
					<div class="breadcrumb-title pe-3">Category</div>
					<div class="ps-3">
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb mb-0 p-0">
								<li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
								</li>
								<li class="breadcrumb-item active" aria-current="page">All Category</li>
							</ol>
						</nav>
					</div>

				</div>
				<!--end breadcrumb-->
				<div class="row">
                    @if(session('msg'))
                        <div class="alert alert-{{ session('type', 'info') }} alert-dismissible fade show" role="alert">
                            {{ session('msg') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
					<div class="col-xl-12 mx-auto">
						<hr/>
						<div class="card">
							<div class="card-body">
								<table class="table table-bordered mb-0">
									<thead class="table-dark">
										<tr>
											<th scope="col">#</th>
											<th scope="col">Name</th>
											<th scope="col">Description</th>
											<th scope="col">Action</th>
										</tr>
									</thead>
									<tbody>
                                        @forelse ($categories as $category)
                                        <tr>
											<th scope="row">{{ $category->id }}</th>
											<td>{{ $category->name }}</td>
											<td>{{ $category->description }}</td>
                                            <td>
                                                <a class="btn btn-sm btn-primary" href="{{ route('admin.categories.edit', $category->id) }}"><i class="fas fa-edit"></i></a>
                                                    <form class="d-inline" action="{{ route('admin.categories.destroy', $category->id) }}" method="POST">
                                                        @csrf
                                                        @method('delete')
                                                        <button onclick="return confirm('Are you sure?!')" class="btn btn-sm btn-danger">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                            </td>
										</tr>
                                    @endforeach
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
				<!--end row-->
</div>
@endsection

