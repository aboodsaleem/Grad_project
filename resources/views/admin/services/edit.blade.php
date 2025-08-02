@extends('admin.admin_Dashboard')
@section('title', 'Edit Service')

@section('admin')
<div class="page-content">
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Services</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit Service</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-9 mx-auto">
            <hr/>
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.services.update', $service->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Service Provider -->
                        <div class="mb-3">
                            <label>Service Provider</label>
                            <select name="service_provider_id" class="form-control @error('service_provider_id') is-invalid @enderror" required>
                                <option value="">Select Service Provider</option>
                                @foreach($providers as $provider)
                                    <option value="{{ $provider->id }}" {{ $service->service_provider_id == $provider->id ? 'selected' : '' }}>
                                        {{ $provider->username ?? 'Unavailable Name' }}
                                    </option>
                                @endforeach
                            </select>
                            @error('service_provider_id')
                                <small class="invalid-feedback">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- Service Name -->
                        <div class="mb-3">
                            <label>Service Name</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                   value="{{ old('name', $service->name) }}" placeholder="Enter the service name" required />
                            @error('name')
                                <small class="invalid-feedback">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- Service Type -->
                        <div class="mb-3">
                            <label>Service Type</label>
                            <select name="serviceType" class="form-control @error('serviceType') is-invalid @enderror" required>
                                <option value="">Select Service Type</option>
                                @foreach(['Electrical','Maintenance','Repairing','Cleaning','Washing'] as $type)
                                    <option value="{{ $type }}" {{ $service->serviceType == $type ? 'selected' : '' }}>{{ $type }}</option>
                                @endforeach
                            </select>
                            @error('serviceType')
                                <small class="invalid-feedback">{{ $message }}</small>
                            @enderror
                        </div>


                        <!-- Price -->
                        <div class="mb-3">
                            <label>Price ($)</label>
                            <input type="number" step="0.01" name="price" class="form-control @error('price') is-invalid @enderror"
                                   value="{{ old('price', $service->price) }}" placeholder="Enter price" required />
                            @error('price')
                                <small class="invalid-feedback">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- Image -->
<div class="mb-3">
    <label>Service Image</label>
    <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" />
    @error('image')
        <small class="invalid-feedback">{{ $message }}</small>
    @enderror

    @if ($service->image)
        <div class="mt-2">
            <img src="{{ asset($service->image) }}" alt="Service Image" width="100">
        </div>
    @endif
</div>

<!-- Description -->
                        <div class="mb-3">
                            <label>Description</label>
                            <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="4"
                                      placeholder="Enter service description" required>{{ old('description', $service->description) }}</textarea>
                            @error('description')
                                <small class="invalid-feedback">{{ $message }}</small>
                            @enderror
                        </div>



                        <button class="btn btn-primary"><i class="fas fa-save mr-1 ml-1"></i> Update Service</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
