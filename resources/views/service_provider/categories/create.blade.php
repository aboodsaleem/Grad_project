@extends('service_provider.serviceprovider_Dashboard')
@section('title', 'Add Category')

@section('service_provider')
<div class="page-content">
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Category</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="{{ route('provider.categories.index') }}"><i class="bx bx-left-arrow-alt"></i></a></li>
                    <li class="breadcrumb-item active" aria-current="page">Add Category</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('provider.categories.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label>Name</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Category Name" value="{{ old('name') }}" />
                    @error('name')
                        <small class="invalid-feedback">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-3">
                    <label>Description</label>
                    <textarea name="description" class="form-control @error('description') is-invalid @enderror" placeholder="Category Description" rows="4">{{ old('description') }}</textarea>
                    @error('description')
                        <small class="invalid-feedback">{{ $message }}</small>
                    @enderror
                </div>

                <button class="btn btn-success"><i class="fas fa-save"></i> Add Category</button>
            </form>
        </div>
    </div>
</div>
@endsection
