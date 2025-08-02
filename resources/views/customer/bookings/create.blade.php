
<!-- Booking Service Modal -->
<div
    class="modal fade"
    id="bookingModal"
    tabindex="-1"
    aria-labelledby="bookingModalLabel"
    aria-hidden="true"
>
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
        <div class="modal-content mx-auto p-2">
            <div class="modal-header">
                <h2 class="fw-semibold fs-5">Booking Service</h2>
                <button
                    type="button"
                    class="btn-close position-absolute end-0 m-3"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                ></button>
            </div>

            <div class="modal-body p-4">
                <form class="booking-form" method="POST" action="{{ route('customer.bookings.store') }}">
                    @csrf

                    <!-- عرض اسم الخدمة (معطّل) -->
                    <div class="input-group align-items-center mb-3">
                        <label for="serviceName" class="me-2">Service</label>
                        <input
                            type="text"
                            class="form-control flex-grow-1 rounded-2"
                            id="serviceName"
                            value=""
                            disabled
                        />
                        <!-- حقل مخفي لإرسال service_id -->
                        <input type="hidden" name="service_id" id="serviceId" value="" />
                    </div>

                    <!-- عرض اسم مزود الخدمة (معطّل) -->
                    <div class="input-group align-items-center mb-3">
                        <label for="providerName" class="me-2">Service Provider</label>
                        <input
                            type="text"
                            class="form-control flex-grow-1 rounded-2"
                            id="providerName"
                            value=""
                            disabled
                        />
                        <input type="hidden" name="service_provider_id" id="providerId" value="" />
                    </div>

                    <!-- اسم العميل (غير مرسل لأنه من الـ auth) -->
                    <div class="input-group align-items-center mb-3">
                        <label for="fullName" class="me-2">Your Name</label>
                        <input
                            type="text"
                            id="fullName"
                            class="form-control flex-grow-1 rounded-2"
                            value="{{ auth()->user()->username ?? '' }}"
                            readonly
                        />
                    </div>

                    <!-- ايميل العميل (غير مرسل لأنه من الـ auth) -->
                    <div class="input-group align-items-center mb-3">
                        <label for="email" class="me-2">Email</label>
                        <input
                            type="email"
                            id="email"
                            class="form-control flex-grow-1 rounded-2"
                            value="{{ auth()->user()->email ?? '' }}"
                            readonly
                        />
                    </div>

                    <!-- حقل التاريخ -->
                    <div class="input-group align-items-center mb-3">
                        <label for="booking_date" class="me-2">Date</label>
                        <input
                            type="date"
                            name="booking_date"
                            id="booking_date"
                            class="form-control flex-grow-1 rounded-2"
                            required
                        />
                    </div>

                    <!-- وقت البداية -->
                    <div class="input-group align-items-center mb-3">
                        <label for="start_time" class="me-2">Start time</label>
                        <input
                            type="time"
                            id="start_time"
                            name="start_time"
                            class="form-control flex-grow-1 rounded-2"
                            required
                        />
                    </div>

                    <!-- وقت النهاية -->
                    <div class="input-group align-items-center mb-3">
                        <label for="end_time" class="me-2">End time</label>
                        <input
                            type="time"
                            id="end_time"
                            name="end_time"
                            class="form-control flex-grow-1 rounded-2"
                            required
                        />
                    </div>

                    <!-- وصف إضافي -->
                    <div class="input-group align-items-start mb-3">
                        <label for="description" class="me-2">Special Requests</label>
                        <textarea
                            id="description"
                            name="description"
                            class="form-control flex-grow-1 rounded-2"
                            placeholder="If you need a special thing"
                        ></textarea>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-primary me-2">Confirm</button>
                        <button type="reset" class="btn btn-secondary">Reset</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
