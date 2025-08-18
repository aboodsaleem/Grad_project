
          <!-- Main Services Content -->
          <div
            class="tab-pane fade services-page"
            id="services"
            role="tabpanel"
          >
            <div
              class="d-flex justify-content-between align-items-center page-header"
            >
              <h2 class="fw-semibold">My Available Services</h2>
              <button
                class="btn btn-primary add-btn"
                data-bs-toggle="modal"
                data-bs-target="#addServiceModal"
              >
                Add New Service
              </button>
            </div>
            <div class="services-grid d-grid gap-20">
                @foreach ( $services as $service)

                 <div
                class="service-card p-20 d-flex flex-column justify-content-center align-items-center"
              >
                <div
                  class="service-icon text-white d-flex justify-content-center align-items-center rounded-circle mb-3"
                >
                @switch($service->serviceType)
                    @case('Electrical')
                        <i class="fas fa-bolt"></i>
                        @break
                    @case('Maintenance')
                        <i class="fas fa-tools"></i>
                        @break
                    @case('Repairing')
                        <i class="fas fa-wrench"></i>
                        @break
                    @case('Cleaning')
                        <i class="fas fa-broom"></i>
                        @break
                    @case('Washing')
                        <i class="fas fa-tint"></i>
                        @break
                    @default
                        <i class="fas fa-cog"></i>
                @endswitch
                </div>
                <h3 class="fw-bold fs-4">{{ $service->serviceType }}</h3>
                <p>
                  {{ $service->description }}
                </p>
                <div class="service-price fw-medium text-success mb-2">
                  Base Price: {{ $service->price }}$
                </div>
                <div class="service-actions">
                  <button
                    class="btn btn-primary edit-btn"
                    data-bs-toggle="modal"
                    data-bs-target="#editServiceModal{{ $service->id }}"
                  >
                    Edit
                  </button>
                   <form action="{{ route('provider.services.destroy' , $service->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                  <button type="button" class="btn btn-secondary delete-btn"  data-url="{{ route('provider.services.destroy', $service->id) }}"
    data-title="هل أنت متأكد من حذف هذه الخدمة؟"
    data-confirm="نعم، احذف"
    data-cancel="إلغاء"
    data-method="DELETE"
    title="حذف">Delete</button>
                   </form>
                </div>
              </div>

                @endforeach
{{--
              <div
                class="service-card p-20 d-flex flex-column justify-content-center align-items-center"
              >
                <div
                  class="service-icon text-white d-flex justify-content-center align-items-center rounded-circle mb-3"
                >
                  <i class="fas fa-tools"></i>
                </div>
                <h3 class="fw-bold fs-4">Furniture Assembly</h3>
                <p>
                  Assembly services for all types of home and office furniture.
                </p>
                <div class="service-price fw-medium text-success mb-2">
                  Base Price: $120
                </div>

                <div class="service-actions">
                  <button
                    class="btn btn-primary edit-btn"
                    data-bs-toggle="modal"
                    data-bs-target="#editServiceModal"
                  >
                    Edit
                  </button>
                  <button class="btn btn-secondary delete-btn">Delete</button>
                </div>
              </div> --}}
            </div>
          </div>
