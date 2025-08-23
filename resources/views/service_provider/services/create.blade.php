<div class="modal fade" id="addServiceModal" tabindex="-1" aria-labelledby="addServiceModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content p-3">
      <div class="modal-header">
        <h5 class="modal-title" id="addServiceModalLabel">Add New Service</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <form action="{{ route('provider.services.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-body">
          <div class="mb-1">
            <label for="name" class="form-label">Service Name</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
          </div>

          <div class="mb-1">
            <label for="serviceType" class="form-label">Service Type</label>
            <select name="serviceType" id="serviceType" class="form-select" required>
              <option value="">Select Service Type</option>
              @foreach(['Electrical','Maintenance','Repairing','Cleaning','Washing'] as $type)
                <option value="{{ $type }}" {{ old('serviceType') == $type ? 'selected' : '' }}>{{ $type }}</option>
              @endforeach
            </select>
          </div>

          <div class="mb-1">
            <label for="price" class="form-label">Price</label>
            <input type="number" name="price" id="price" class="form-control" step="0.01" min="0" value="{{ old('price') }}" required>
          </div>

          <div class="mb-1">
            <label for="image" class="form-label">Image</label>
            <input type="file" name="image" id="image" class="form-control" accept="image/*">
          </div>

          <div class="mb-1">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" id="description" class="form-control" rows="3" required>{{ old('description') }}</textarea>
          </div>
        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Add Service</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        </div>
      </form>
    </div>
  </div>
</div>
