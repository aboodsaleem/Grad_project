<div class="modal fade" id="editServiceModal{{ $service->id }}" tabindex="-1" aria-labelledby="editServiceModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content p-2">
      <div class="modal-header">
        <h2 class="fw-semibold fs-5">Edit Service</h2>
        <button type="button" class="btn-close position-absolute end-0 m-3" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="{{ route('provider.services.update', $service->id) }}" method="POST" enctype="multipart/form-data">
          @csrf
          @method('PUT')

          <div class="mb-1">
            <label for="serviceName{{ $service->id }}" class="form-label">Service Name</label>
            <input type="text" class="form-control" id="serviceName{{ $service->id }}" name="name" value="{{ $service->name }}" required>
          </div>

          <div class="mb-1">
            <label for="serviceType{{ $service->id }}" class="form-label">Service Type</label>
            <select id="serviceType{{ $service->id }}" name="serviceType" class="form-select" required>
              @foreach(['Electrical','Maintenance','Repairing','Cleaning','Washing'] as $type)
                <option value="{{ $type }}" {{ $service->serviceType === $type ? 'selected' : '' }}>{{ $type }}</option>
              @endforeach
            </select>
          </div>

          <div class="mb-1">
            <label for="price{{ $service->id }}" class="form-label">Price</label>
            <input type="number" class="form-control" id="price{{ $service->id }}" name="price" step="0.01" min="0" value="{{ $service->price }}" required>
          </div>

          <div class="mb-1">
            <label for="image{{ $service->id }}" class="form-label">Image</label>
            @if ($service->image)
              <div class="mb-2"><img src="{{ asset($service->image) }}" alt="Service Image" width="150" class="rounded"></div>
            @endif
            <input type="file" name="image" id="image{{ $service->id }}" class="form-control" accept="image/*">
          </div>

          <div class="mb-1">
            <label for="description{{ $service->id }}" class="form-label">Description</label>
            <textarea class="form-control" id="description{{ $service->id }}" name="description" rows="3" required>{{ $service->description }}</textarea>
          </div>

          <div class="mb-2 form-check">
            <input type="checkbox" class="form-check-input" id="status{{ $service->id }}" name="status" value="1" {{ $service->status ? 'checked' : '' }}>
            <label class="form-check-label" for="status{{ $service->id }}">Check if this service is active</label>
          </div>

          <button type="submit" class="btn btn-primary">Update Service</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        </form>
      </div>
    </div>
  </div>
</div>
