@extends('admin.admin_Dashboard')
@section('title', 'Add Service')

@section('admin')
<div class="page-content">
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Services</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item active" aria-current="page">Add Service</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-9 mx-auto">
            <hr/>
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.services.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Service Provider -->
                        <div class="mb-3">
                            <label>Service Provider</label>
                            <select name="service_provider_id" class="form-control @error('service_provider_id') is-invalid @enderror" required>
                                <option value="">Select Service Provider</option>
                                @foreach($providers as $provider)
                                    <option value="{{ $provider->id }}" {{ old('service_provider_id') == $provider->id ? 'selected' : '' }}>
                                        {{ $provider->username ?? 'Name Not Available' }}
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
                                   value="{{ old('name') }}" placeholder="Enter the service name" required />
                            @error('name')
                                <small class="invalid-feedback">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- Service Type -->
                        <div class="mb-3">
                            <label>Service Type</label>
                            <select name="serviceType" class="form-control @error('serviceType') is-invalid @enderror" required>
                                <option value="">Select Service Type</option>
                                <option value="Electrical" {{ old('serviceType') == 'Electrical' ? 'selected' : '' }}>Electrical</option>
                                <option value="Maintenance" {{ old('serviceType') == 'Maintenance' ? 'selected' : '' }}>Maintenance</option>
                                <option value="Repairing" {{ old('serviceType') == 'Repairing' ? 'selected' : '' }}>Repairing</option>
                                <option value="Cleaning" {{ old('serviceType') == 'Cleaning' ? 'selected' : '' }}>Cleaning</option>
                                <option value="Washing" {{ old('serviceType') == 'Washing' ? 'selected' : '' }}>Washing</option>
                            </select>
                            @error('serviceType')
                                <small class="invalid-feedback">{{ $message }}</small>
                            @enderror
                        </div>



                        <!-- Price -->
                        <div class="mb-3">
                            <label>Price</label>
                            <input type="number" step="0.01" name="price" class="form-control @error('price') is-invalid @enderror"
                                   value="{{ old('price') }}" placeholder="Price" required />
                            @error('price')
                                <small class="invalid-feedback">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- Service Image -->
<div class="mb-3">
    <label>Service Image</label>
    <input type="file" name="image" accept="image/*" class="form-control @error('image') is-invalid @enderror" />
    @error('image')
        <small class="invalid-feedback">{{ $message }}</small>
    @enderror
</div>

 <!-- Description -->
                        <div class="mb-3">
                            <label>Description</label>
                            <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="4"
                                      placeholder="Service Description" required>{{ old('description') }}</textarea>
                            @error('description')
                                <small class="invalid-feedback">{{ $message }}</small>
                            @enderror
                        </div>

                        <button class="btn btn-success"><i class="fas fa-save mr-1 ml-1"></i> Add Service</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
