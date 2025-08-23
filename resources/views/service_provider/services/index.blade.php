<div class="tab-pane fade services-page" id="services" role="tabpanel">
  <div class="d-flex justify-content-between align-items-center page-header">
    <h2 class="fw-semibold">My Available Services</h2>
    <button class="btn btn-primary add-btn" data-bs-toggle="modal" data-bs-target="#addServiceModal">Add New Service</button>
  </div>

  <div class="services-grid d-grid gap-20">
      

    @forelse ($services as $service)
      <div class="service-card p-20 d-flex flex-column justify-content-center align-items-center border rounded">
        <div class="service-icon text-white d-flex justify-content-center align-items-center rounded-circle mb-3">
          @switch($service->serviceType)
            @case('Electrical') <i class="fas fa-bolt"></i> @break
            @case('Maintenance') <i class="fas fa-tools"></i> @break
            @case('Repairing') <i class="fas fa-wrench"></i> @break
            @case('Cleaning') <i class="fas fa-broom"></i> @break
            @case('Washing') <i class="fas fa-tint"></i> @break
            @default <i class="fas fa-cog"></i>
          @endswitch
        </div>
        <h3 class="fw-bold fs-4">{{ $service->name ?? $service->serviceType }}</h3>
        @if($service->image)
          <img src="{{ asset($service->image) }}" alt="Service Image" class="rounded mb-2" style="max-width: 220px;">
        @endif
        <p class="text-center">{{ $service->description }}</p>
        <div class="service-price fw-medium text-success mb-2">
          Base Price: {{ number_format($service->price, 2) }}
        </div>
        <div class="service-actions d-flex gap-2">
          <button class="btn btn-primary edit-btn" data-bs-toggle="modal" data-bs-target="#editServiceModal{{ $service->id }}">Edit</button>

          <form action="{{ route('provider.services.destroy' , $service->id) }}" method="POST">
            @csrf @method('DELETE')
            <button type="submit" class="btn btn-secondary delete-btn" onclick="return confirm('Are you sure to delete this service?')">Delete</button>
          </form>
        </div>
      </div>
    @empty
      <div class="text-center text-muted py-4">No services yet.</div>
    @endforelse
  </div>
</div>
