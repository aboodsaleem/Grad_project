<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Service Provider Dashboard - Home Services</title>
    <link rel="stylesheet" href="{{ asset('frontend/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('frontend/css/all.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('frontend/css/dashboard.css') }}" />

    <link
      href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;600;700&display=swap"
      rel="stylesheet"
    />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" >

  </head>
  <body>
    <div class="dashboard-container d-flex min-vh-100">

@include('service_provider.body.sidebar')



      <!-- Main Content -->
      <main class="main-content flex-grow-1" id="mainContent">
        <!-- Top Header -->
@include('service_provider.body.header')
        <!-- Page Content -->
@yield('main')
      </main>

      <!-- Add Service Modal -->
      <div
        class="modal fade"
        id="addServiceModal"
        tabindex="-1"
        aria-labelledby="addServiceModalLabel"
        aria-hidden="true"
      >
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
          <div class="modal-content mx-auto p-2">
            <div class="modal-header">
              <h2 class="fw-semibold fs-5">Add New Service</h2>
              <button
                type="button"
                class="btn-close position-absolute end-0 m-3"
                data-bs-dismiss="modal"
                aria-label="Close"
              ></button>
            </div>
            <div class="modal-body">
              <form>
                <div class="mb-3">
                  <label for="serviceName" class="form-label"
                    >Service Name</label
                  >
                  <input type="text" class="form-control" id="serviceName" />
                </div>

                <!-- Service Icon -->
                <select id="serviceIcon" class="form-select" hidden>
                  <option value="cleaning">
                    <i class="fas fa-broom"></i>
                  </option>
                  <option value="repairing">
                    <i class="fas fa-wrench"></i>
                  </option>
                  <option value="washing"></option>
                  <option value="electrical">
                    <i class="fas fa-bolt"></i>
                  </option>
                  <option value="maintenance">
                    <i class="fas fa-tools"></i>
                  </option>
                </select>

                <div class="mb-3">
                  <label for="serviceType" class="form-label"
                    >Service Type</label
                  >
                  <select id="serviceType" class="form-select">
                    <option value="electrical">Electrical</option>
                    <option value="maintenance">Maintenance</option>
                    <option value="repairing">Repairing</option>
                    <option value="cleaning">Cleaning</option>
                    <option value="washing">Washing</option>
                  </select>
                </div>

                <div class="mb-3">
                  <label for="price" class="form-label">Price</label>
                  <input type="number" class="form-control" id="price" />
                </div>

                <div class="mb-3">
                  <label for="description" class="form-label"
                    >Description</label
                  >
                  <textarea
                    type="text"
                    class="form-control"
                    id="description"
                  ></textarea>
                </div>

                <div class="mb-3 form-check">
                  <input
                    type="checkbox"
                    class="form-check-input"
                    id="exampleCheck1"
                    checked="true"
                  />
                  <label class="form-check-label" for="exampleCheck1"
                    >Check out, If you need service active for now</label
                  >
                </div>
                <button type="submit" class="btn btn-primary">
                  Add Service
                </button>
              </form>
            </div>
          </div>
        </div>
      </div>

      <!-- Edit Service Modal -->
      <div
        class="modal fade"
        id="editServiceModal"
        tabindex="-1"
        aria-labelledby="editServiceModalLabel"
        aria-hidden="true"
      >
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
          <div class="modal-content p-2">
            <div class="modal-header">
              <h2 class="fw-semibold fs-5">Edit Service Name</h2>
              <button
                type="button"
                class="btn-close position-absolute end-0 m-3"
                data-bs-dismiss="modal"
                aria-label="Close"
              ></button>
            </div>
            <div class="modal-body">
              <form>
                <div class="mb-3">
                  <label for="serviceName" class="form-label"
                    >Service Name</label
                  >
                  <input
                    type="text"
                    class="form-control"
                    id="serviceName"
                    value="Pest Control"
                  />
                </div>

                <!-- Service Icon -->
                <select id="serviceIcon" class="form-select" hidden>
                  <option value="cleaning">
                    <i class="fas fa-broom"></i>
                  </option>
                  <option value="repairing">
                    <i class="fas fa-wrench"></i>
                  </option>
                  <option value="washing"></option>
                  <option value="electrical">
                    <i class="fas fa-bolt"></i>
                  </option>
                  <option value="maintenance">
                    <i class="fas fa-tools"></i>
                  </option>
                </select>

                <div class="mb-3">
                  <label for="serviceType" class="form-label"
                    >Service Type</label
                  >
                  <select id="serviceType" class="form-select">
                    <option value="electrical">Electrical</option>
                    <option value="maintenance">Maintenance</option>
                    <option value="repairing">Repairing</option>
                    <option value="cleaning">Cleaning</option>
                    <option value="washing">Washing</option>
                  </select>
                </div>

                <div class="mb-3">
                  <label for="price" class="form-label">Price</label>
                  <input
                    type="number"
                    class="form-control"
                    id="price"
                    value="120"
                  />
                </div>

                <div class="mb-3">
                  <label for="description" class="form-label"
                    >Description</label
                  >
                  <textarea type="text" class="form-control" id="description">
Effective pest control services using safe and approved chemicals.
                  </textarea>
                </div>

                <div class="mb-3 form-check">
                  <input
                    type="checkbox"
                    class="form-check-input"
                    id="status"
                    checked="true"
                  />
                  <label class="form-check-label" for="status"
                    >Check out, If you need service active for now</label
                  >
                </div>
                <button type="submit" class="btn btn-primary">
                  Edit Service
                </button>
                <button type="reset" class="btn btn-secondary">Reset</button>
              </form>
            </div>
          </div>
        </div>
      </div>

      <!-- Confirmed Booking Details Modal -->
      <div
        class="modal fade"
        id="confirmedBookingDetailsModal"
        tabindex="-1"
        aria-labelledby="confirmedBookingDetailsModalLabel"
        aria-hidden="true"
      >
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
          <div class="modal-content mx-auto p-4 rounded-4 shadow-sm border-0">
            <!-- Header -->
            <div class="modal-header border-0">
              <h2 class="fs-4 fw-semibold mb-0">Booking Details</h2>
              <button
                type="button"
                class="btn-close"
                data-bs-dismiss="modal"
                aria-label="Close"
              ></button>
            </div>

            <!-- Body -->
            <div class="modal-body">
              <!-- Booking Info -->
              <div class="mb-4">
                <p class="mb-3"><strong>Service:</strong> Home Cleaning</p>
                <p class="mb-3"><strong>Client:</strong> Mohamed Ali</p>
                <p class="mb-3"><strong>Date:</strong> 2024-01-16</p>
                <p class="mb-3"><strong>Time:</strong> 10:00 AM</p>
                <p>
                  <strong>Status:</strong>
                  <span class="badge status confirmed">Confirmed</span>
                </p>
              </div>

              <hr class="my-3" />

              <!-- Waiting Notice -->
              <div
                class="d-flex align-items-center gap-3 p-3 bg-light rounded-3"
              >
                <!-- Icon -->
                <div class="text-primary fs-3">
                  <i class="fas fa-clock"></i>
                </div>

                <!-- Message -->
                <div>
                  <h6 class="fw-bold mb-1">Awaiting Completion</h6>
                  <p class="mb-0 text-muted small">
                    This booking has been confirmed. Once completed, you will
                    receive a review from the customer.
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Rated Booking Details Modal Completed Booking -->
      <div
        class="modal fade"
        id="ratedBookingDetailsModal"
        tabindex="-1"
        aria-labelledby="ratedBookingDetailsModalLabel"
        aria-hidden="true"
      >
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
          <div class="modal-content mx-auto p-4 rounded-4 shadow-sm border-0">
            <!-- Header -->
            <div class="modal-header border-0">
              <h2 class="fs-4 fw-semibold mb-0">Booking Summary</h2>
              <button
                type="button"
                class="btn-close"
                data-bs-dismiss="modal"
                aria-label="Close"
              ></button>
            </div>

            <!-- Body -->
            <div class="modal-body">
              <!-- Booking Info -->
              <div class="mb-4">
                <p class="mb-3"><strong>Service:</strong> Plumbing Repair</p>
                <p class="mb-3"><strong>Client:</strong> Fatima Khalid</p>
                <p class="mb-3"><strong>Date:</strong> 2025-07-16</p>
                <p class="mb-3">
                  <strong>Time:</strong>
                  <span class="start-time">4:00 PM</span> -
                  <span class="end-time">6:00 PM</span>
                </p>
                <p>
                  <strong>Status:</strong>
                  <span class="status fw-medium text-center completed"
                    >Completed</span
                  >
                </p>
              </div>

              <hr class="my-3" />

              <!-- Review Card -->
              <div
                class="d-flex align-items-start gap-3 bg-light rounded-3 p-3"
              >
                <!-- Avatar -->
                <img
                  src="https://via.placeholder.com/60x60?text=User"
                  alt="Customer Avatar"
                  class="rounded-circle"
                  width="60"
                  height="60"
                  onerror="this.src='{{ asset('frontend/public/assest/default-customer-image.png') }}';"
                />

                <!-- Review Content -->
                <div class="flex-grow-1">
                  <h6 class="fw-bold mb-1">Fatima Khalid</h6>

                  <!-- Star Rating -->
                  <div class="text-warning mb-2 fs-5">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="far fa-star"></i>
                    <span class="ms-2 text-muted fs-6">(4.0)</span>
                  </div>

                  <!-- Feedback Text -->
                  <p class="mb-0 fst-italic text-muted">
                    “Very cooperative and polite. Service was great and on
                    time.”
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Edit Profile Modal -->
      <div
        class="modal fade"
        id="profileModal"
        tabindex="-1"
        aria-labelledby="profileModalLabel"
        aria-hidden="true"
      >
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
          <div class="modal-content mx-auto p-3">
            <div class="modal-header">
              <h2 class="fs-5 fw-semibold mb-0">Edit Profile</h2>
              <button
                type="button"
                class="btn-close"
                data-bs-dismiss="modal"
                aria-label="Close"
              ></button>
            </div>

            <div class="modal-body">
              <form action="{{ route('Service_Provider.update',$service_provider->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <!-- Full Name -->
                <div class="mb-3">
                  <label for="fullName" class="form-label">Full Name</label>
                  <input
                    name="username"
                    type="text"
                    class="form-control"
                    id="fullName"
                    placeholder="Enter full name"
                    value="{{ $service_provider->username }}"
                  />
                </div>

                <!-- Phone -->
                <div class="mb-3">
                  <label for="phone" class="form-label">Phone Number</label>
                  <input
                    name="phone"
                    type="tel"
                    class="form-control"
                    id="phone"
                    placeholder="+966 50 123 4567"
                    value="{{ $service_provider->phone }}"
                  />
                </div>

                <!-- Email -->
                <div class="mb-3">
                  <label for="email" class="form-label">Email</label>
                  <input
                    name="email"
                    type="email"
                    class="form-control"
                    id="email"
                    placeholder="eissam@example.com"
                    value="{{ $service_provider->email }}"
                  />
                </div>

                <!-- City -->
                <div class="mb-3">
                  <label for="city" class="form-label">City</label>
                  <input
                    name="city"
                    type="text"
                    class="form-control"
                    id="city"
                    placeholder="City"
                    value="{{ $service_provider->city }}"
                  />
                </div>

                <!-- Address -->
                <div class="mb-3">
                  <label for="address" class="form-label">Address</label>
                  <input
                    name="address"
                    type="text"
                    class="form-control"
                    id="address"
                    placeholder="Address"
                    value="{{ $service_provider->address }}"
                  />
                </div>

                <!-- Data Of Birthday -->
                <div class="mb-3">
                  <label for="dob" class="form-label">Date Of BirthDay</label>
                  <input
                    name="date_of_birth"
                    type="date"
                    class="form-control"
                    id="dob"
                    placeholder="Date Of BirthDay"
                    value="{{ $service_provider->date_of_birth }}"
                  />
                </div>

                <!-- Profile Image Upload -->
                <div class="d-flex align-items-center justify-content-between">
                  <label
                    for="profileImageInput"
                    class="small mb-0"
                    style="width: 150px"
                    >Upload Image</label
                  >
                  <input
                    name="photo"
                    type="file"
                    class="form-control form-control-sm flex-fill"
                    accept="image/*"
                    id="profileImageInput"
                  />
                </div>

                <!-- Save Button -->
                <div class="d-flex justify-content-end mt-5">
                  <button type="submit" class="btn btn-primary">
                    Save Changes
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>

      <!-- Change password modal -->
      <div
        class="modal fade"
        id="changePassModal"
        tabindex="-1"
        aria-labelledby="changePassModalLabel"
        aria-hidden="true"
      >
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="updatePhoneNumberModalLabel">
                Change Password
              </h1>
              <button
                type="button"
                class="btn-close"
                data-bs-dismiss="modal"
                aria-label="Close"
              ></button>
            </div>
            <div class="modal-body">
              <form id="modalForm" method="POST" action="{{ route('Service_Provider.update.password',$service_provider->id) }}">
                @csrf
                <div class="form-group">
                  <label for="modalInput">Enter new value:</label>
                  <input
                    type="text"
                    name="new_password"
                    id="modalInput"
                    class="form-control"
                    required
                    style="width: 100%; padding: 8px; margin-top: 5px"
                  />
            @error('new_password')
            <span class="text-danger">{{ $message }}</span>
            @enderror
                </div>

                <div class="mt-4 text-end">
                  <button
                    type="reset"
                    class="btn btn-secondary"
                    data-bs-dismiss="modal"
                  >
                    Close
                  </button>
                  <button type="submit" class="btn btn-primary" id="saveBtn">
                    Save changes
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>

      <!-- Update email modal -->
      <div
        class="modal fade"
        id="updateEmailModal"
        tabindex="-1"
        aria-labelledby="updateEmailModalLabel"
        aria-hidden="true"
      >
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="updateEmailModalLabel">
                Update Email
              </h1>
              <button
                type="button"
                class="btn-close"
                data-bs-dismiss="modal"
                aria-label="Close"
              ></button>
            </div>
            <div class="modal-body">
        <form id="emailUpdateForm" method="POST" action="{{ route('Service_Provider.update.email',$service_provider->id) }}">
                @csrf
                <div class="form-group">
                  <label for="modalInput">Enter new value:</label>
                  <input
                    type="text"
                    name="email"
                    id="emailInput"
                    class="form-control emailInput"
                    required
                    value="{{ $service_provider->email }}"
                    style="width: 100%; padding: 8px; margin-top: 5px"
                  />
            @error('email')
            <span class="text-danger">{{ $message }}</span>
            @enderror

                </div>

                <div class="mt-4 text-end">
                  <button
                    type="reset"
                    class="btn btn-secondary"
                    data-bs-dismiss="modal"
                  >
                    Close
                  </button>
                  <button type="submit" class="btn btn-primary" id="saveBtn">
                    Save changes
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>

      <!-- Update phone_number modal -->
      <div
        class="modal fade"
        id="updatePhoneModal"
        tabindex="-1"
        aria-labelledby="updatePhoneModalLabel"
        aria-hidden="true"
      >
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="updatePhoneModalLabel">
                Update Phone Number
              </h1>
              <button
                type="button"
                class="btn-close"
                data-bs-dismiss="modal"
                aria-label="Close"
              ></button>
            </div>
            <div class="modal-body">

            <form id="phoneUpdateForm" method="POST" action="{{ route('Service_Provider.update.phone',$service_provider->id) }}">
            @csrf
                <div class="form-group">
                  <label for="phoneInput">Enter new value:</label>
                  <input
                    name="phone"
                    type="text"
                    id="phoneInput"
                    class="form-control"
                    required
                    style="width: 100%; padding: 8px; margin-top: 5px"
                    value="{{ $service_provider->phone}}"
                  />
                  @error('phone')
                    <span class="text-danger">{{ $message }}</span>
                  @enderror
                </div>

                <div class="mt-4 text-end">
                  <button
                    type="reset"
                    class="btn btn-secondary"
                    data-bs-dismiss="modal"
                  >
                    Close
                  </button>
                  <button type="submit" class="btn btn-primary" id="saveBtn">
                    Save changes
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
    <script src="{{ asset('frontend/js/bootstrap.bundle.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
    <script>
      const notyf = new Notyf();
    </script>
    <script type="module" src="{{ asset('frontend/js/providerDashboard.js') }}"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
    @if(Session::has('message'))
 var type = "{{ Session::get('alert-type','info') }}"
 switch(type){
    case 'info':
    toastr.info(" {{ Session::get('message') }} ");
    break;

    case 'success':
    toastr.success(" {{ Session::get('message') }} ");
    break;

    case 'warning':
    toastr.warning(" {{ Session::get('message') }} ");
    break;

    case 'error':
    toastr.error(" {{ Session::get('message') }} ");
    break;
 }
 @endif
 </script>
  </body>
</html>






