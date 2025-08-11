
<div class="tab-pane fade favorites-page" id="favorites" role="tabpanel">
    <div class="d-flex justify-content-between align-items-center page-header">
        <h2 class="fw-semibold">My Favorite Services</h2>
    </div>

    <div class="services-grid d-grid gap-20">
        @forelse($Favoriteservices as $service)
            <div class="service-card p-20 bg-white text-center position-relative" data-category="{{ $service->serviceType }}">
                <button class="btn p-0 fav-btn">
                    <a aria-label="Add To favorite" class="action-btn" id="{{ $service->id }}" onclick="addTofavorite(this.id)">
                        <i class="fas fa-heart fav-icon" style="color: red;"></i>
                    </a>
                </button>

                <div class="service-image d-flex align-items-center justify-content-center text-white rounded-circle">
                    @switch($service->serviceType)
                        @case('Electrical') <i class="fas fa-bolt"></i> @break
                        @case('Maintenance') <i class="fas fa-tools"></i> @break
                        @case('Repairing') <i class="fas fa-wrench"></i> @break
                        @case('Cleaning') <i class="fas fa-broom"></i> @break
                        @case('Washing') <i class="fas fa-tint"></i> @break
                        @default <i class="fas fa-cog"></i>
                    @endswitch
                </div>

                <h3 class="fw-semibold mb-2 title">{{ $service->name }}</h3>
                <p class="mb-3 description">{{ $service->description }}</p>

                <div class="service-rating d-flex align-items-center justify-content-center gap-10 mb-3">
                    <div class="rating">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i>
                        <i class="fas fa-star"></i><i class="fas fa-star"></i>
                        <i class="far fa-star"></i>
                    </div>
                    <span><b>4.5</b></span>
                </div>

                <div class="service-price fw-semibold mb-3">From {{ $service->price }} $</div>
                <div class="date mb-2 text-gray">
                    <b>Available time</b>: 08:00am - 08:00pm
                </div>

                <div class="service-actions d-flex gap-10 justify-content-center">
            <button class="btn btn-primary remove-favorite-btn" data-service-id="{{ $service->id }}">
                Remove from Favorites
            </button>

                    <button
                        class="btn btn-secondary view-details-btn"
                        data-bs-toggle="modal"
                        data-bs-target="#serviceModal"
                        data-name="{{ $service->name }}"
                        data-description="{{ $service->description }}"
                        data-price="{{ $service->price }}"
                        data-provider="{{ $service->serviceProvider->username ?? 'Unknown' }}"
                        data-photo="{{ asset($service->serviceProvider->photo ?? 'upload/no_img.jpg') }}"
                        data-category="{{ $service->serviceType }}"
                        data-rating="4.5"
                        data-location="{{ $service->serviceProvider->location ?? 'Not specified' }}"
                        data-status="{{ $service->status ?? 'Available' }}"
                    >
                        Details
                    </button>
                </div>
            </div>
        @empty
            <p>No services available at the moment.</p>
        @endforelse
    </div>
</div>

