@extends('admin.admin_Dashboard')
@section('title', 'All Services')

@section('admin')
<div class="page-content">
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Services</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item active" aria-current="page">All Services</li>
                </ol>
            </nav>
        </div>
    </div>

    <form method="GET" action="{{ route('admin.services.index') }}">
    <div class="row">
        <!-- Service Type -->
        <div class="col-sm-3">
            <div class="mb-3">
                <label class="form-label">Service Type</label>
                <select name="serviceType" class="form-control">
                    <option value="">Select Type</option>
                    @foreach(['Electrical','Maintenance','Repairing','Cleaning','Washing'] as $type)
                        <option value="{{ $type }}" {{ request('serviceType') == $type ? 'selected' : '' }}>
                            {{ $type }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Provider Name -->
        <div class="col-sm-3">
            <div class="mb-3">
                <label class="form-label">Provider Name</label>
                <input type="text" class="form-control" name="provider_name" value="{{ request('provider_name') }}">
            </div>
        </div>

        <!-- Price -->
        <div class="col-sm-3">
            <div class="mb-3">
                <label class="form-label">Price</label>
                <input type="number" step="0.01" class="form-control" name="price" value="{{ request('price') }}">
            </div>
        </div>

    </div>

    <button type="submit" class="btn btn-primary">Search</button>
    <a href="{{ route('admin.services.index') }}" class="btn btn-danger">Reset</a>
</form>
<br>

    <div class="card radius-10">
        <div class="card-body">
            <div class="d-flex align-items-center">
				<div>
					<h5 class="mb-0">All Services</h5>
				</div>
				<div class="font-22 ms-auto">
                    <a href="{{ route('admin.services.create') }}" class="btn btn-success"> <i class="fas fa-plus"></i> Add New Service</a>
				</div>
				</div>
				<hr>
            <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Service Type</th>
                        <th>Price</th>
                        <th>Service Provider</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($services as $service)
                        <tr>
                            <td class="fw-bold">{{ $service->id }}</td>
                            <td>{{ $service->name }}</td>
                            <td>{{ $service->serviceType }}</td>
                            <td>{{ number_format($service->price, 2) }} $</td>
                            <td>{{ $service->serviceProvider->username ?? '-' }}</td>
                            <td>
                                <a href="{{ route('admin.services.edit', $service->id) }}" class="btn btn-sm btn-info" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <form action="{{ route('admin.services.destroy', $service->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-danger btn-sm delete-btn"
    data-url="{{ route('admin.services.destroy', $service->id) }}"
    data-title="هل أنت متأكد من حذف هذه الخدمة؟"
    data-confirm="نعم، احذف"
    data-cancel="إلغاء"
    data-method="DELETE"
    title="حذف">
    <i class="fas fa-trash-alt"></i>
</button>

                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center">  Not Found Services</td></tr>
                    @endforelse
                </tbody>
            </table>

            {{ $services->links() }}
        </div>
        </div>
    </div>
</div>
@endsection
@section('js')
@include('admin.partials.sweetalert_actions')
@endsection
