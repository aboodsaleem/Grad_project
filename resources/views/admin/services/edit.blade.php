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

                        <div class="mb-3">
                            <label>Service Provider</label>
                            <select name="service_provider_id" class="form-control @error('service_provider_id') is-invalid @enderror" required>
                                <option value="">اختر مزود الخدمة</option>
                                @foreach($providers as $provider)
                                    <option value="{{ $provider->id }}" {{ old('service_provider_id', $service->service_provider_id) == $provider->id ? 'selected' : '' }}>
                                        {{ $provider->username ?? 'اسم غير متوفر' }}
                                    </option>
                                @endforeach
                            </select>
                            @error('service_provider_id')
                                <small class="invalid-feedback">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label>Title</label>
                            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                                   value="{{ old('title', $service->title) }}" placeholder="Service Title" required />
                            @error('title')
                                <small class="invalid-feedback">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label>Description</label>
                            <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="4"
                                      placeholder="Service Description" required>{{ old('description', $service->description) }}</textarea>
                            @error('description')
                                <small class="invalid-feedback">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label>Price</label>
                            <input type="number" step="0.01" name="price" class="form-control @error('price') is-invalid @enderror"
                                   value="{{ old('price', $service->price) }}" placeholder="Price" required />
                            @error('price')
                                <small class="invalid-feedback">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label>Current Photo</label><br>
                            @if($service->image)
                                <img src="{{ asset($service->image) }}" style="width:100px; height:auto;" alt="Service Photo">
                            @else
                                <p>لا توجد صورة</p>
                            @endif
                        </div>

                        <div class="mb-3">
                            <label>Change Photo</label>
                            <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" />
                            @error('image')
                                <small class="invalid-feedback">{{ $message }}</small>
                            @enderror
                        </div>

                        <button class="btn btn-primary"><i class="fas fa-edit mr-1 ml-1"></i> Update Service</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
